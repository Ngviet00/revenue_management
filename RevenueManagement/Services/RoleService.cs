using AutoMapper;
using Microsoft.EntityFrameworkCore;
using RevenueManagement.Context;
using RevenueManagement.Models.Entities;

namespace RevenueManagement.Services
{
    public class RoleService
    {
        private readonly ApplicationDbContext context;
        private readonly IMapper mapper;

        public RoleService(ApplicationDbContext context, IMapper mapper) 
        {
            this.mapper = mapper;
            this.context = context;
        }

        public async Task<List<Role>> GetAll()
        {
            return await this.context.Roles.AsNoTracking().ToListAsync();
        }

        public async Task<List<Role>> GetAllIgnoreSuperAdmin()
        {
            return await this.context.Roles.AsNoTracking().Where(p => p.Id != 1).ToListAsync();
        }
    }
}
