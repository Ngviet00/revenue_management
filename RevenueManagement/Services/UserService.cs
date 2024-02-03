using AutoMapper;
using Microsoft.EntityFrameworkCore;
using RevenueManagement.Context;
using RevenueManagement.Models.DTOs.User;
using RevenueManagement.Models.Entities;

namespace RevenueManagement.Services
{
    public class UserService
    {
        private readonly ApplicationDbContext _context;
        private readonly IMapper _mapper;

        public UserService(ApplicationDbContext _context, IMapper _mapper)
        {
            this._context = _context;
            this._mapper = _mapper;
        }

        public async Task<UserDto>? GetById(long userId)
        {
            return _mapper.Map<UserDto>(await _context.Users.AsNoTracking().FirstOrDefaultAsync(x => x.Id == userId));
        }

        public async Task<bool> ChangePassword(UserDto userDto, string newPassword)
        {
            try
            {
                var eUser = _mapper.Map<User>(userDto);
                eUser.Password = Utils.Security.MD5Hash(newPassword);
                
                _context.Entry(eUser).State = EntityState.Modified;
                await _context.SaveChangesAsync();
                
                return true;
            }
            catch (Exception exception)
            {
                Console.WriteLine(exception);
                return false;
            }
        }
    }
}
