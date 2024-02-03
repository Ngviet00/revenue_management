using AutoMapper;
using Microsoft.EntityFrameworkCore;
using RevenueManagement.Context;
using RevenueManagement.Models.Requests.User;

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
        
        public async Task<bool> CheckPassword(ChangePasswordRequest request, long currentUserId)
        {
            var user = await _context.Users.FirstOrDefaultAsync(x => x.Id == currentUserId);
            
            if (user == null)
            {
                return false;
            }

            if (user.Password != Utils.Security.MD5Hash(request.CurrentPassword))
            {
                return false;
            }
            var password = request.NewPassword;

            var a = 1;
            return true;
        }
    }
}
